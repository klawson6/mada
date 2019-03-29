"use strict";

function ChatView(){
    var chatHistoryDiv, chatForm, postTextField;


    this.init = function(){
        chatHistoryDiv = document.getElementById("chatHistoryDiv");
        chatForm = document.getElementById("chatForm");
        postTextField = document.getElementById("messageText");
        postTextField.focus();
    };

    this.addMessage = function(message,left){
      var chatHistoryDiv = document.getElementById("chatHistoryDiv");
      if(left===1){
          chatHistoryDiv.innerHTML = chatHistoryDiv.innerHTML + "<div class='parent'><div class = 'leftU'><p>" + message + "</p></div></div><br>";
        //  chatHistoryDiv.innerHTML.sty.cssFloat = "left";
      }
      else{
          chatHistoryDiv.innerHTML = chatHistoryDiv.innerHTML + "<div class='parent'><div class = 'rightU'><p>" + message + "</p></div></div><br>";
          //chatHistoryDiv.style.cssFloat = "right";
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