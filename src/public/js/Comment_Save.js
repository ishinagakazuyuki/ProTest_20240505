document.addEventListener("DOMContentLoaded", function () {
    const textarea = document.getElementById("comment");

    // ページが読み込まれたときにローカルストレージからデータを取得してテキストエリアに設定する
    const savedValue = localStorage.getItem("textareaValue");
    if (savedValue) {
        textarea.value = savedValue;
    }

    // テキストエリアの値が変更されたときに、その値をローカルストレージに保存する
    textarea.addEventListener("input", function () {
        const textareaValue = this.value;
        localStorage.setItem("textareaValue", textareaValue);
    });
});