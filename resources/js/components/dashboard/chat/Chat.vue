<template>
<v-content>
		<v-container fluid>
    <v-col xs12 sm6 offset-sm3>
      <v-card class="chat-card" >

        <v-list>
          <v-subheader
            >
              Group Chat
            </v-subheader>
            <v-divider></v-divider>
              <v-list
               class="p-3"
              v-for="(message, index) in allMessages"
              :key="index">
              <v-layout
              :align-end="(userId==message.user.id)"
              column
              >
              <v-flex>
                <v-layout column>
                  <v-flex>
                    <span class="small font-italic">{{message.user.name}}</span>
                  </v-flex>
                  <v-flex>
                    <v-chip
                    :color="(userId==message.user.id)?'red':'green'"
                    text-color="white"
                    >
                    <v-list-item-content>
                      {{message.message}}
                    </v-list-item-content>
                    </v-chip>
                  </v-flex>
                   <v-flex class="caption font-italic">
                  {{message.created_at}}
              </v-flex>
                </v-layout>
              </v-flex>
              </v-layout>
              </v-list>
            <!-- <message-list :user="user" :all-messages="allMessages"></message-list> -->
        </v-list>
      </v-card>

    </v-col>

      <div class="floating-div">
          <!-- <picker v-if="emoStatus" set="emojione" @select="onInput" title="Pick your emoji…" /> -->

      </div>

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
              single-line
            ></v-text-field>
        </v-col>
        <v-col xs4>
            <v-btn  @click="sendMessage"
             dark class="mt-3 ml-2 white--text" small color="green">send</v-btn>
        </v-col>
      </v-row>
    </v-footer>
		</v-container>s
		</v-content>
</template>


<script>
  export default {
    data: () => ({
      
      userId:'',
        editedItem:
        {
          message:'',
        },
        allMessages:[],
     
    }),
    methods:
         {
                  async sendMessage() 
                        {
                          
                          // this.allMessages.push(this.editedItem.message);
                          try {
                            let { data } = await axios({
                              method: "post",
                              url: "/app/sendmessages",
                              data: this.editedItem
                            });
                            this.editedItem.message=''
                            this.fetchMessages();
                            setTimeout(this.scrollToEnd,100);
                          } catch (e) {}

                        },
                
                async fetchMessages() 
                        {
                          try {
                              let { data } = await axios({
                                method: "get",
                                url: "/app/getmessages"
                              });
                              this.allMessages = data;
                            } catch (e) {}

                        },

            scrollToEnd()
                     {
                         window.scrollTo(0,99999);
                       },
      },
       mounted()
       {
         Echo.private('lchat')
          .listen('MessageSent',(e)=>{
              this.allMessages.push(e.message)
              setTimeout(this.scrollToEnd,100);

          });
        },
      created()
      {
        this.fetchMessages();
        this.userId = this.$store.state.authUser.id
      }

  }
</script>
