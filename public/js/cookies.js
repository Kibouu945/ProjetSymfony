
document.getElementById('accept-cookies').addEventListener('click', function() {
    fetch('/accept-cookies', {
        method: 'POST', 
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ accept: true })
    })
    .then(response => response.json())
    .then(data => {
        if (data.accepted) {
            document.getElementById('cookie-banner').style.display = 'none';
        }
    });
});