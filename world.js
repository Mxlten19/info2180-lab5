document.addEventListener('DOMContentLoaded', function() {
    const lookupButton = document.getElementById('lookup');
    const countryInput = document.getElementById('country');
    const resultDiv = document.getElementById('result');
    
    lookupButton.addEventListener('click', async function(event) {
        event.preventDefault();
        
        const country = countryInput.value.trim();
        
        let url = 'world.php';
        if (country) {
            url += '?country=' + encodeURIComponent(country);
        }
        
        try {
            const response = await fetch(url);
            
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            
            const html = await response.text();
            resultDiv.innerHTML = html;
            
        } catch (error) {
            resultDiv.innerHTML = `<p>Error: ${error.message}</p>`;
        }
    });
});