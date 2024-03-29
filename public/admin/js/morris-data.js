$(function() {

    Morris.Donut({
        element: 'morris-donut-chart',
        data: [{
            label: "Gum disease",
            value: 12
        }, {
            label: "Missing Teeth",
            value: 30
        }, {
            label: "Sensitivity",
            value: 10
        }, {
            label: "Dry mouth",
            value: 20
        }, {
            label: "Oropharyngeal Cancer",
            value: 5
        }],
        resize: true
    });

    Morris.Bar({
        element: 'morris-bar-chart',
        data: [{
            y: '2006',
            a: 100,
            b: 90
        }, {
            y: '2007',
            a: 75,
            b: 65
        }, {
            y: '2008',
            a: 50,
            b: 40
        }, {
            y: '2009',
            a: 75,
            b: 65
        }, {
            y: '2010',
            a: 50,
            b: 40
        }, {
            y: '2011',
            a: 75,
            b: 65
        }, {
            y: '2012',
            a: 100,
            b: 90
        }],
        xkey: 'y',
        ykeys: ['a', 'b'],
        labels: ['Series A', 'Series B'],
        hideHover: 'auto',
        resize: true
    });

});
