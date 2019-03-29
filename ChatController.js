/*global ChatView*/
/*global ChatModel*/
"use strict";

function ChatController() {
    var model = new ChatModel(),
        view = new ChatView();

    this.init = function () {
        model.init();
        view.init();

        model.setShowNewPostCallBack(function(message,left){
           view.addMessage(message,left);
        });

        view.setCallbackForMessagePost(model.post);
    };
}

var chatController = new ChatController();
window.addEventListener('load', chatController.init);