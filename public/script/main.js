const URL_DISCUSSION_API = 'http://clickclack.cfpt.loc/API/main.php?id=';

async function getAllMessagesFromOneDiscussion(id) {
    try {
        const response = await fetch(`${URL_DISCUSSION_API}${id}`);
        const messages = await response.json();

        console.log(messages);
        const container = document.querySelector(".messages-box");
        container.innerHTML = "";

        messages.forEach(msg => {
            const messageDiv = document.createElement("div");
            messageDiv.classList.add("message");

            messageDiv.innerHTML = `
                <div class="avatar">
                    ${msg.pseudoCreateur.charAt(0).toUpperCase()}
                </div>

                <div class="message-content">

                    <div class="message-author">
                        ${msg.pseudoCreateur}
                    </div>

                    <div class="message-bubble">
                        ${msg.text}
                    </div>

                </div>
            `;

            container.appendChild(messageDiv);
        });

    } catch (e) {
        console.error("Erreur API :", e);
    }
}

window.getAllMessagesFromOneDiscussion = getAllMessagesFromOneDiscussion;

document.addEventListener("DOMContentLoaded", () => {

    const parts = window.location.pathname.split('/');
    const id = parts[parts.length - 1];

    if (!isNaN(id)) {

        getAllMessagesFromOneDiscussion(id);
        setInterval(() => {
            getAllMessagesFromOneDiscussion(id);
        }, 6000);
    }

});

