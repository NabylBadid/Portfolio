function onClickBtnLike(event) {
    event.preventDefault();
    // this dans un événement, fait référence à l'élémént qui a déclenché l'événement
    const url = this.href;
    const spanCount = this.querySelector('span.js-likes');
    const spanText = this.querySelector('span.js-label');
    const icon = this.querySelector('svg');
    const iconAttr = icon.getAttribute('data-prefix');

    axios.get(url).then(function (response) { // then = si 
        spanCount.textContent = response.data.likes;

        if (iconAttr == 'fas') {
            icon.setAttribute('data-prefix', 'far');
            spanText.textContent = "J'aime";
        } else { 
            icon.setAttribute('data-prefix', 'fas');
            spanText.textContent = "Je n'aime plus";
        }
    }).catch(function(error) {
        if (error.response.status != undefined && error.response.status === 403) {
            window.alert("Vous ne pouvez pas liker un projet si vous n'êtes pas connecté");
        } else {
            window.alert("Une erreur s'est produite, réessayez plus tard");
        }
    });
}

document.querySelectorAll('a.js-like').forEach(function (link) {
    link.addEventListener('click', onClickBtnLike);
});