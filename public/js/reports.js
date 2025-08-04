document.addEventListener('DOMContentLoaded', function () {
    console.log('Initializing chart for visitsChart');
    const canvas = document.getElementById('visitsChart');
    if (!canvas) {
        console.error('Canvas element visitsChart not found');
        return;
    }

    if (canvas.chart) {
        console.log('Destroying existing chart instance');
        canvas.chart.destroy();
    }

    const ctx = canvas.getContext('2d');
    if (!ctx) {
        console.error('Failed to get canvas context');
        return;
    }

    canvas.chart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: window.chartData.labels,
            datasets: [{
                label: 'Jumlah Kunjungan',
                data: window.chartData.data,
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            animation: false,
            scales: {
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Jumlah Kunjungan'
                    }
                },
                x: {
                    title: {
                        display: true,
                        text: window.chartData.period === 'daily' ? 'Tanggal' : 'Bulan'
                    }
                }
            },
            plugins: {
                legend: {
                    display: true
                },
                tooltip: {
                    enabled: true
                }
            }
        }
    });
    console.log('Chart initialized successfully');
});

window.addEventListener('beforeunload', function () {
    const canvas = document.getElementById('visitsChart');
    if (canvas && canvas.chart) {
        canvas.chart.destroy();
        console.log('Chart destroyed on page unload');
    }
});