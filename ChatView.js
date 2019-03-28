"use strict";

function ChatView(){
    this.init = function(){

    };

    this.addMessage = function(message){
      var chatHistoryDiv = document.getElementById("chatHistoryDiv");
      chatHistoryDiv.innerHTML = chatHistoryDiv.innerHTML + "<p>" + message + "</p>";
    };
}