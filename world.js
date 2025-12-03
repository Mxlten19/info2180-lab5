document.addEventListener('DOMContentLoaded', function() {
    const lookupButton = document.getElementById('lookup');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');
    
    lookupButton.addEventListener('click', function(event) {
        event.preventDefault(); 
        
        const country = countryInput.value.trim();
        
        const xhr = new XMLHttpRequest();
        
        let url = 'world.php';
        if (country) {
            url += '?country=' + encodeURIComponent(country);
        }
        
        xhr.open('GET', url, true);

        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 400) {
                resultDiv.innerHTML = xhr.responseText;
            } else {
                resultDiv.innerHTML = '<p>Error loading data. Please try again.</p>';
            }
        };

        xhr.onerror = function() {
            resultDiv.innerHTML = '<p>Network error. Please check your connection.</p>';
        };
        
        xhr.send();
    });
});