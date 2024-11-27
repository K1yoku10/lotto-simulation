then(data => {
    if (data.error) {
        document.getElementById('result').innerHTML = `<p style="color:red;">${data.error}</p>`;
        return;
    }
form.addEventListener('submit', function(event) {
    event.preventDefault();
     document.getElementById('loader').style.display = 'block'
    document.getElementById('result').innerHTML = '<p>Przetwarzanie...</p>';
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    form.addEventListener('submit', function(event) {
        event.preventDefault(); // Zapobiegaj domyślnemu wysłaniu formularza
        const inputs = document.querySelectorAll('input[type="number"]');
        let numbers = [];
        for (let input of inputs) {
            let value = parseInt(input.value);
            if (isNaN(value) || value < 1 || value > 49) {
                alert("Wszystkie liczby muszą być z zakresu od 1 do 49.");
                event.preventDefault();
                return;
            }
            if (numbers.includes(value)) {
                alert("Liczby muszą być unikalne.");
                event.preventDefault();
                return;
            }
            numbers.push(value);
        }
        const formData = new FormData(form);
        fetch('process.php', {
            method: 'POST',
            body: formData
        })
        .then(data => {
            if (data.error) {
                document.getElementById('loader').style.display = 'none';
                document.getElementById('result').innerHTML = `<p style="color:red;">${data.error}</p>`;
                return;
            }
            let output = `
                <p>Twoje liczby: ${data.userNumbers.join(', ')}</p>
                <p>Wylosowane liczby: ${data.randomNumbers.join(', ')}</p>
                <p>Trafiłeś ${data.numberOfMatches} liczb(y): ${data.matches.join(', ')}</p>
                <p>Twoja wygrana: ${data.prize}</p>
            `;
            document.getElementById('result').innerHTML = output;
        })
        .catch(error => {
            document.getElementById('loader').style.display = 'none';
            console.error('Błąd:', error);
        });
    });    
        
    });
});
});