<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>AI Chat Interface</title>
  <link rel="stylesheet" href="style.css">
  <style>
  
    .modal {
      display: none;
      position: fixed;
      top: 0; left: 0; right: 0; bottom: 0;
      background: rgba(0,0,0,0.7);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    .modal.active { display: flex; }
  </style>
</head>
<body>

  <div class="container">
    <div class="header">
      <div class="header-left">
        <img class="zoom-image" src="assets/image/peep2.gif" alt="">
      </div>
      <button class="share-btn">Share</button>
    </div>

    <div class="main-content">
      <h1 id="typingText" class="main-title">
        HELLO ,<br>
        <span>Meu nome é PEEP</span>
      </h1>
      <p class="subtitle">I'm cool</p>
    </div>

    <div class="footer">
      <div class="footer-links">
        <a href="#">Base system</a>
        <a href="#">Team lookup</a>
        <a href="#">Contacts</a>
      </div>
      <button class="chat-btn" onclick="openChat()">Chat</button>
    </div>
  </div>

  <!-- Chat Modal -->
  <div id="chatModal" class="modal">
    <div class="modal-content">
      <div class="modal-header">
        <span class="icon">+ ••</span>
        <button class="close-btn" onclick="closeChat()">Close X</button>
      </div>
      <div class="chat-body" id="chatBody">
        <div class="message bot-message">
          Hello!<br>Ask me anything. I'll answer everything :)
        </div>
      </div>
      <div class="input-area">
        <input type="text" id="userInput" placeholder="Message" onkeypress="if(event.key==='Enter') sendMessage()" />
        <button onclick="sendMessage()">Send ↑</button>
      </div>
    </div>
  </div>

  <script>
    // Open / Close Modal
    function openChat() {
      document.getElementById('chatModal').classList.add('active');
    }

    function closeChat() {
      document.getElementById('chatModal').classList.remove('active');
    }

    
    async function sendMessage() {
      const input = document.getElementById('userInput');
      const message = input.value.trim();
      if (!message) return;

      const chatBody = document.getElementById('chatBody');

      //mensagem do usuario
      const userMsg = document.createElement('div');
      userMsg.className = 'message user-message';
      userMsg.innerHTML = message.replace(/\n/g, '<br>');
      chatBody.appendChild(userMsg);
      input.value = '';
      scrollToBottom();

      
      const typing = document.createElement('div');
      typing.className = 'message bot-message typing';
      typing.innerHTML = '<em>PEEP is typing...</em>';
      chatBody.appendChild(typing);
      scrollToBottom();

      try {
        // 3. manda pro PHP
        const response = await fetch('chat.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
          body: 'message=' + encodeURIComponent(message)
        });

        
        const data = await response.json();

        
        typing.remove();

        
        const botMsg = document.createElement('div');
        botMsg.className = 'message bot-message';
        botMsg.innerHTML = (data.reply || 'No response').replace(/\n/g, '<br>');
        chatBody.appendChild(botMsg);
        scrollToBottom();

      } catch (error) {
        typing.remove();
        const errMsg = document.createElement('div');
        errMsg.className = 'message bot-message';
        errMsg.innerHTML = '<em style="color:red;">Error: Could not reach server.</em>';
        chatBody.appendChild(errMsg);
        console.error(error);
        scrollToBottom();
      }
    }

    
    function scrollToBottom() {
      const chatBody = document.getElementById('chatBody');
      chatBody.scrollTop = chatBody.scrollHeight;
    }

    // Enter para enviar (Shift+Enter)
    document.getElementById('userInput').addEventListener('keydown', function(e) {
      if (e.key === 'Enter' && !e.shiftKey) {
        e.preventDefault();
        sendMessage();
      }
    });
  </script>
</body>
</html>