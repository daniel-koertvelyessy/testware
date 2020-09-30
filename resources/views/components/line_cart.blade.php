<script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>

<canvas id="{{ $id }}" aria-label="Schadensmeldungen pro Woche" role="img"></canvas>

<script>
    const divId{{ $id }} = document.getElementById('{{ $id }}').getContext('2d');
    const chart{{ $id }} = new Chart(divId{{ $id }}, {
        type: 'bar',
        // The data for our dataset
        data: {
    {{ $slot }}
        },
        labels: ['Mo', 'Di', 'Mi', 'Do', 'Fr', 'Sa', 'So'],
        datasets: [{
            label: '{{ $label }}',
            backgroundColor: 'rgb(255,20,68,002)',
            borderColor: 'rgb(96,17,34)',
            data: [0, 1, 1, 8, 2, 1, 0],
            borderWidth:2,
            borderSkipped:'bottom',
        }],
        // Configuration options go here
        options: { {{ $options??'' }} }
    });
</script>
