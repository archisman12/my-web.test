
<!-- The core Firebase JS SDK is always required and must be listed first -->
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-app.js"></script>

<!--include firebase database -->
<script src="https://www.gstatic.com/firebasejs/8.6.3/firebase-database.js"></script>

<!-- TODO: Add SDKs for Firebase products that you want to use
     https://firebase.google.com/docs/web/setup#available-libraries -->
     
<title>clear all your doubts</title>

<script>
  // Your web app's Firebase configuration
  var firebaseConfig = {
    apiKey: "AIzaSyB5I3jsrxs1E06S_eBGaiqZiq-c3aKmpyk",
    authDomain: "clear-doubt-8320b.firebaseapp.com",
    projectId: "clear-doubt-8320b",
    storageBucket: "clear-doubt-8320b.appspot.com",
    messagingSenderId: "962440269392",
    appId: "1:962440269392:web:8e11527c2dcb770bce0b55"
  };
  // Initialize Firebase
  firebase.initializeApp(firebaseConfig);
  var myName = prompt("Enter your name to ask your doubt to the teacher");
  function sendMessage() {
      var message = document.getElementById("message").value;
      firebase.database().ref("messages").push().set({
          "sender":myName,
          "message":message
      });
      return false
  }
  //listen for incoming messages
  firebase.database().ref("messages").on("child_added",function(snapshot){
      var html="";
      html +="<li id='message-" + snapshot.key +"'>";
      //show delete button if message is sent by me
      if (snapshot.val().sender == myName) {
          html += "<button data-id='"+ snapshot.key +"'onclick='deleteMessage(this);'>";
            html += "Delete";
          html+= "</button>"
      }
        html +=snapshot.val().sender + ": " + snapshot.val().message;
      html +="</li>";
      document.getElementById("messages").innerHTML +=html;
  });
  function deleteMessage(self) {
    // get message ID
    var messageId = self.getAttribute("data-id");
 
    // delete message
    firebase.database().ref("messages").child(messageId).remove();
}
 
// attach listener for delete message
firebase.database().ref("messages").on("child_removed", function (snapshot) {
    // remove message node
    document.getElementById("message-" + snapshot.key).innerHTML = "This message has been removed";
});
</script>

<!-- create a form to send message -->
<form onsubmit="return sendMessage();">
  <input id="message" placeholder="Enter your doubt...." autocomplte="off">
  <input type="submit">
</form>
<!-- create a list -->
<ul id="messages"></ul>