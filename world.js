document.addEventListener('DOMContentLoaded', function() {
    const lookupButton = document.getElementById('lookup');
    const lookupCitiesButton = document.getElementById('lookupCities');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');
    
    function makeRequest(lookupType, event) {
        event.preventDefault(); 
        
        const country = countryInput.value.trim();
        
        const xhr = new XMLHttpRequest();
        
        let url = 'world.php';
        let params = [];
        
        if (country) {
            params.push('country=' + encodeURIComponent(country));
        }
        
        if (lookupType === 'cities') {
            params.push('lookup=cities');
        }
        
        if (params.length > 0) {
            url += '?' + params.join('&');
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
    }
    
    lookupButton.addEventListener('click', function(event) {
        makeRequest('countries', event);
    });
    
    lookupCitiesButton.addEventListener('click', function(event) {
        makeRequest('cities', event);
    });
});