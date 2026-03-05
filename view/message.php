<div class="container chat-container">

    <div class="chat-header">
        <?= ucfirst($discussion->titre) ?>
    </div>

    <div class="messages-box">

        <?php foreach ($messages as $message) { ?>
            
            <div class="message">
                
                <div class="avatar">
                    <?= strtoupper(substr($message->pseudoCreateur,0,1)) ?>
                </div>

                <div class="message-content">

                    <div class="message-author">
                        <?= $message->pseudoCreateur ?>
                    </div>

                    <div class="message-bubble">
                        <?= htmlspecialchars($message->text) ?>
                    </div>

                </div>

            </div>

        <?php } ?>

    </div>

    <form action="/discussion/<?= $discussion->idDiscussion ?>" method="post" class="chat-input">

        <input type="text" name="messageText" placeholder="Écrire un message..." required>

        <button type="submit">➤</button>

    </form>

</div>