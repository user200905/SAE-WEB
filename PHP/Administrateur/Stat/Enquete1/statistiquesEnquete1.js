// statistique.js

// Utilisation des données passées depuis PHP
var ctx = document.getElementById('ageChart').getContext('2d');
var ageChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Moins de 18', '18-25', '26-35', '36-45', '46-55', '56+'],
        datasets: [{
            label: 'Répartition des âges',
            data: [
                ageData['Moins de 18'],
                ageData['18-25'],
                ageData['26-35'],
                ageData['36-45'],
                ageData['46-55'],
                ageData['56+']
            ],
            backgroundColor: ['#ff9999', '#66b3ff', '#99ff99', '#ffcc99', '#c2c2f0', '#ffb3e6'],
            borderColor: '#ffffff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            tooltip: {
                callbacks: {
                    label: function(tooltipItem) {
                        return tooltipItem.label + ": " + tooltipItem.raw + " participants";
                    }
                }
            }
        }
    }
});
