@props([
    'id' => 'chart-' . uniqid(),
    'type' => 'line', // line, area, bar, pie, donut, radar, polarArea
    'height' => 350,
    'width' => '100%',
    'options' => [],
    'series' => [],
    'labels' => [],
    'colors' => [],
    'title' => '',
    'subtitle' => '',
    'xaxisTitle' => '',
    'yaxisTitle' => '',
    'enableAnimation' => true,
    'enableDataLabels' => false,
    'enableLegend' => true,
    'enableGrid' => true,
    'enableTooltip' => true,
    'enableZoom' => false,
    'stacked' => false,
    'horizontal' => false,
    'theme' => 'light', // light, dark
    'class' => '',
])

@php
    // Prepare default options
    $defaultOptions = [
        'chart' => [
            'id' => $id,
            'type' => $type,
            'height' => $height,
            'width' => $width,
            'toolbar' => [
                'show' => $enableZoom,
                'tools' => [
                    'download' => true,
                    'selection' => true,
                    'zoom' => true,
                    'zoomin' => true,
                    'zoomout' => true,
                    'pan' => true,
                    'reset' => true,
                ],
            ],
            'animations' => [
                'enabled' => $enableAnimation,
            ],
            'stacked' => $stacked,
            'horizontal' => $horizontal,
        ],
        'theme' => [
            'mode' => $theme,
            'palette' => 'palette1',
        ],
        'dataLabels' => [
            'enabled' => $enableDataLabels,
        ],
        'legend' => [
            'show' => $enableLegend,
            'position' => 'bottom',
        ],
        'grid' => [
            'show' => $enableGrid,
        ],
        'tooltip' => [
            'enabled' => $enableTooltip,
        ],
    ];

    // Add title if provided
    if (!empty($title)) {
        $defaultOptions['title'] = [
            'text' => $title,
            'align' => 'center',
        ];
    }

    // Add subtitle if provided
    if (!empty($subtitle)) {
        $defaultOptions['subtitle'] = [
            'text' => $subtitle,
            'align' => 'center',
        ];
    }

    // Add x-axis title if provided
    if (!empty($xaxisTitle)) {
        $defaultOptions['xaxis']['title'] = [
            'text' => $xaxisTitle,
        ];
    }

    // Add y-axis title if provided
    if (!empty($yaxisTitle)) {
        $defaultOptions['yaxis']['title'] = [
            'text' => $yaxisTitle,
        ];
    }

    // Add labels if provided
    if (!empty($labels)) {
        $defaultOptions['labels'] = $labels;
    }

    // Add colors if provided
    if (!empty($colors)) {
        $defaultOptions['colors'] = $colors;
    }

    // Merge custom options with defaults
    $chartOptions = array_merge_recursive($defaultOptions, $options);

    // Convert options to JSON for ApexCharts
    $chartOptionsJson = json_encode($chartOptions);
    $seriesJson = json_encode($series);
@endphp

<div id="{{ $id }}-container" class="{{ $class }}">
    <div id="{{ $id }}" class="w-full"></div>
</div>

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize ApexCharts
            const options = {!! $chartOptionsJson !!};
            const series = {!! $seriesJson !!};

            // Create chart instance
            const chart = new ApexCharts(document.querySelector("#{{ $id }}"), {
                ...options,
                series: series
            });

            // Render chart
            chart.render();

            // Handle theme changes if needed
            document.addEventListener('dark-mode', function(e) {
                const isDarkMode = e.detail.darkMode;
                chart.updateOptions({
                    theme: {
                        mode: isDarkMode ? 'dark' : 'light'
                    }
                });
            });
        });
    </script>
@endpush
