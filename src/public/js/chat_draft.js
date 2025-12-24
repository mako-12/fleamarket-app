document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('chat-input');
    if (!input) return;

    const transactionId = input.dataset.transactionId;
    const storageKey = `chat_draft_${transactionId}`;

    //ヘージ読み込み時に復元
    const saved = localStorage.getItem(storageKey);
    if (saved) {
        input.value = saved;
    }

    //入力するたびに保存
    input.addEventListener('input', () => {
        localStorage.setItem(storageKey, input.value);
    });

    //送信したら削除
    const form = input.closest('form');
    form.addEventListener('submit', () => {
        localStorage.removeItem(storageKey);
    });
});
