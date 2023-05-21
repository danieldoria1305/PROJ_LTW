document.addEventListener("DOMContentLoaded", function () {
    var hashtagsInput = document.getElementById("hashtags-input");
    var hashtagsContainer = document.getElementById("hashtags-container");
    var submitHashtagButton = document.getElementById("submit-hashtag");

    submitHashtagButton.addEventListener("click", function () {
        var hashtag = hashtagsInput.value.trim();

        if (hashtag !== "") {
            var hashtagElement = document.createElement("span");
            hashtagElement.classList.add("hashtag");
            hashtagElement.innerHTML = hashtag + '<button class="remove-hashtag" type="button">X</button>';
            hashtagsContainer.appendChild(hashtagElement);

            hashtagsInput.value = "";

            updateHiddenInputValue();
        }
    });

    hashtagsContainer.addEventListener("click", function (event) {
        if (event.target.classList.contains("remove-hashtag")) {
            var hashtagElement = event.target.parentNode;
            hashtagElement.parentNode.removeChild(hashtagElement);

            updateHiddenInputValue();
        }
    });

    function updateHiddenInputValue() {
        var hashtags = Array.from(hashtagsContainer.getElementsByClassName("hashtag"))
            .map(function (element) {
              return element.firstChild.textContent;
            })
            .join(",");

        document.getElementById("hashtags").value = hashtags;
    }
});
