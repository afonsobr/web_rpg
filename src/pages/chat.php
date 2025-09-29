<div id="chatHistory" style="padding-bottom: 70px;">
    <div style="flex: 1; flex-grow: 1; overflow-y: auto;" class="message-area">

    </div>
    <div class="w-100 input-area">
        <form class="chat-input d-flex" onsubmit="sendMessage(event)">
            <input type="text" id="chatInput" placeholder="Type your message" autocomplete="off">
            <button type="submit" id="chatSubmit">
                <i class="fa-solid fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<style>
    #chatInput {
        background-color: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        color: var(--color-text);
        border-radius: 9999px;
        padding: 15px 15px;
        border: 0px;
        width: calc(100%);
        margin-right: 10px;
    }

    #chatInput:focus {
        outline: none;
    }

    #chatSubmit {
        cursor: pointer;
        background-color: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        color: var(--color-text);
        border-radius: 9999px;
        padding: 10px;
        text-align: center;
        border: 0px;
        font-size: 18px;
        line-height: 15px;
    }
</style>

<style>
    .input-area {
        position: fixed;
        bottom: 90px;
        left: 50%;
        transform: translateX(-50%);
        width: calc(100% - 20px);
        max-width: 500px;
        z-index: 10;
    }
</style>