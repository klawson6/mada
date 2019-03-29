"use strict";

function ChatView(){
    var chatHistoryDiv, chatForm, postTextField;


    this.init = function(){
        chatHistoryDiv = document.getElementById("chatHistoryDiv");
        chatForm = document.getElementById("chatForm");
        postTextField = document.getElementById("messageText");
        postTextField.focus();
        document.getElementById("name").innerHTML = otherEmail;
    };

    this.addMessage = function(message,left){
      var chatHistoryDiv = document.getElementById("chatHistoryDiv");
      if(left===1){
          //chatHistoryDiv.innerHTML = chatHistoryDiv.innerHTML + "<h3>" + message + "</h3>";
          chatHistoryDiv.style.cssFloat = "left";
      }
      else{
          //chatHistoryDiv.innerHTML = chatHistoryDiv.innerHTML + "<p>" + message + "</p>";
          chatHistoryDiv.style.cssFloat = "right";
      }
    };

    this.setCallbackForMessagePost = function(callback){
        chatForm.addEventListener("submit", function(event){
            window.console.log("Text: " + postTextField.value);
            callback(postTextField.value);
            postTextField.value = "";
            postTextField.focus();
            event.preventDefault();
        });
    };

}