const hashtagsInput = document.getElementById("hashtags-input");
const hashtagsContainer = document.getElementById("hashtags-container");
const hashtagsField = document.getElementById("hashtags");
const hashtagsAutocomplete = document.getElementById("hashtags-autocomplete");

const updateHashtags = () => {
    const hashtags = Array.from(hashtagsContainer.getElementsByClassName("hashtag")).map((span) => span.textContent.trim());
    hashtagsField.value = hashtags.join(",");
};

const showAutocompleteSuggestions = (suggestions) => {
    hashtagsAutocomplete.innerHTML = "";
    suggestions.forEach((suggestion) => {
        const suggestionElement = document.createElement("div");
        suggestionElement.textContent = suggestion;
        suggestionElement.classList.add("autocomplete-suggestion");
        suggestionElement.addEventListener("click", () => {
        hashtagsInput.value = suggestion;
        hashtagsAutocomplete.innerHTML = "";
        hashtagsInput.focus();
        });
        hashtagsAutocomplete.appendChild(suggestionElement);
    });
};

hashtagsInput.addEventListener("input", () => {
    const input = hashtagsInput.value.trim();
    if (input !== "") {
        const request = new XMLHttpRequest();
        request.onreadystatechange = () => {
        if (request.readyState === XMLHttpRequest.DONE && request.status === 200) {
            const suggestions = JSON.parse(request.responseText);
            showAutocompleteSuggestions(suggestions);
        }
        };
        request.open("GET", `../actions/action_fetchHashtagSuggestions.php?input=${encodeURIComponent(input)}`);
        request.send();
    } else {
        hashtagsAutocomplete.innerHTML = "";
    }
});
