var grafic1 = new Chart(document.getElementById("grafic1"), {
	type: 'line',
	data: {
		labels: lastMonths,
		datasets: [{
			label: 'Quantidade',
			data: dataLastMonths,
			fill: false,
			backgroundColor: '#0000FF',
			bordercolor: '#0000FF'
		}]
	}
});

var grafic2 = new Chart(document.getElementById("grafic2"), {
	type: 'pie',
	data: {
		labels: nextMonths,
		datasets: [{
			label: 'Quantidade',
			data: dataNextMonths,
			backgroundColor: ['#0000FF','#FF55CC','#FFEE55']
		}]
	}
});
