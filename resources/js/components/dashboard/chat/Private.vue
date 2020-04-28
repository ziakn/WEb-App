<template>
<v-content>
		<v-container fluid>
  <v-row >
    <v-col  lg="3">
      <v-card
         >
    <v-list  >
      <v-subheader>Users</v-subheader>
      <v-list-item-group active-class color="primary">
        <v-list-item
          v-for="freindData in friends"
            :key="freindData.id"
              @click="fetchMessages(freindData)"
        >
          <v-list-item-icon>
            <v-icon >account_circle</v-icon>
          </v-list-item-icon>
          <v-list-item-content>
            <v-list-item-title>{{freindData.name}}</v-list-item-title>
          </v-list-item-content>
          <v-list-item-action>
              <v-icon :color="(onlineFriends.find(onlineFriends=>onlineFriends.id==freindData.id))?'green':'red'">account_circle</v-icon>
            </v-list-item-action>
        </v-list-item>
      </v-list-item-group>
    </v-list>
  </v-card>
  </v-col>
    
    <v-col id="privateMessageBox"  lg="9">
        <v-card  scrollable>
      <v-list shaped>
          <v-subheader
            >
              Chat
            </v-subheader>
            <v-divider></v-divider>
              <v-list
              
              v-for="(message, index) in allMessages"
              :key="index">
              <v-layout
              :align-end="(userId==message.user.id)"
              column
              >
            <v-list-item>
                <v-layout column>
                   <v-list-item>
                    <v-list-item-title >{{message.user.name}}</v-list-item-title> 
                   </v-list-item>
                  <v-list-item>
                    <v-chip
                    :color="(userId==message.user.id)?'green':'red'"
                    text-color="white"
                    >
                    <v-list-item-content>
                      {{message.message}}
                    </v-list-item-content>
                    </v-chip>
                  </v-list-item>
                   <v-flex >
                    <v-list-item-subtitle>{{message.created_at}}</v-list-item-subtitle>
                  
              </v-flex>
                </v-layout>
            </v-list-item>
              </v-layout>
              </v-list>
              
        <p v-if="typingFriend.name">{{typingFriend.name}} is typing ...</p>
        </v-list>
        
         <v-footer
      height="auto"
     
      color="grey"
      >
      <v-row row >
          <v-col class="ml-2 text-right" xs1>
              <v-btn  fab dark small color="pink">
                  <v-icon>insert_emoticon </v-icon>
              </v-btn>
          </v-col>

          <v-col xs1 class="text-center">
        

        </v-col>
        <v-col xs6 >
            <v-text-field
              rows=2
              label="Enter Message"
               v-model="editedItem.message"
               @keyup="onTyping"
              single-line
            ></v-text-field>
        </v-col>
        <v-col xs4>
            <v-btn  @click="sendMessage"
             dark class="mt-3 ml-2 white--text" small color="green">send</v-btn>
        </v-col>
      </v-row>
    </v-footer>
        </v-card>
    </v-col>

  </v-row>
		</v-container>
</v-content>
</template>

<script>

  export default {
    components:{
     
    },
    data: () => ({
      
      userId:'',
        editedItem:
        {
          message:'',
          receiver_id:''
        },
       activeFriend:null,
       typingFriend:{},
        allMessages:[],
        onlineFriends:[],
        typingClock:null,
           users:[],
     
    }),
    watch:
    {
     
        activeFriend(val){
        this.fetchMessages();
        
      },
    },
    computed:
    {
      friends()
      {
        return this.users.filter((user)=>{
          return user.id != this.userId;
        })
      }
    },
    created()
      {
       
           this.initialize();
        this.userId = this.$store.state.authUser.id
      },
    methods:
         {

                  async initialize()
                  {
                      this.fetchUsers();
                      // this.fetchMessages();
                  },

                  onTyping()
                  {
                      Echo.private('privatechat.'+this.editedItem.receiver_id).whisper('typing',{
                        user:this.$store.state.authUser
                      });
                  },

                  async sendMessage() 
                        {
                          
                          try {
                            let { data } = await axios({
                              method: "post",
                              url: "/app/privatesendmessages",
                              data: this.editedItem
                            });
                            this.editedItem.message=''
                            this.fetchMessages();
                            setTimeout(this.scrollToEnd,100);
                          } catch (e) {}

                        },
                
                async fetchMessages(freindData) 
                        {
                          if(freindData)
                          {
                            this.editedItem.receiver_id=freindData.id
                            this.activeFriend=freindData.id
                          
                          }
                          
                          try {
                              let { data } = await axios({
                                method: "post",
                                url: "/app/privategetmessages",
                                data : this.editedItem
                              });
                               this.allMessages = data;
                            } catch (e) {}

                        },

                async fetchUsers() 
                        {
                          try {
                              let { data } = await axios({
                                method: "get",
                                url: "/app/privateusers"
                              });
                              this.users = data;
                              this.editedItem.receiver_id=this.friends[0].id;
                               this.activeFriend=this.friends[0].id;
                            } catch (e) {}

                            this.fetchMessages();

                        },

            scrollToEnd()
                     {
                         window.scrollTo(0,99999);
                       },
      },
       mounted()
       {

         Echo.join('plchat')
              .here((users) => {
                   console.log('online',users);
                   this.onlineFriends=users;
              })
              .joining((user) => {
                  this.onlineFriends.push(user);
                  console.log('joining',user.name);
              })
              .leaving((user) => {
                  this.onlineFriends.splice(this.onlineFriends.indexOf(user),1);
                  console.log('leaving',user.name);
              });


         Echo.private('privatechat.'+this.userId)
          .listen('PrivateMessageSent',(e)=>{
             this.activeFriend=e.message.user_id;
              this.allMessages.push(e.message)
              setTimeout(this.scrollToEnd,100);

          })
          .listenForWhisper('typing', (e) => {
             if(e.user.id==this.activeFriend){
                      this.typingFriend=e.user;
                       if(this.typingClock) clearTimeout();

                      this.typingClock=setTimeout(()=>{
                                            this.typingFriend={};
                                        },9000);
             }
            });
            
        },
      

  }
</script>
