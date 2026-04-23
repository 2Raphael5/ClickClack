<?php
$loadDiscussionScript = true
?>
<div class="container chat-container">

    <div class="chat-header">
        <?= ucfirst($discussion->titre) ?>
    </div>

    <div class="messages-box">


    </div>


    <form action="/discussion/<?= $discussion->idDiscussion ?>" method="post" class="chat-input">
        <?php
        if (!empty($_SESSION['User'])) {
            ?>
            <input type="text" name="messageText" placeholder="Écrire un message..." required>

            <button type="submit">➤</button>
            <?php
        }
        ?>

    </form>

</div>