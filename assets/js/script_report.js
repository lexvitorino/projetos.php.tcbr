function openPopupClients(obj) {
	var data = $(obj).serialize();
	var url = BASE_URL+"/reports/clients_pdf?"+data;
	window.open(url, "clients_rep", "width=800,height=600");
	return false;
}

function openPopupCompanies(obj) {
	var data = $(obj).serialize();
	var url = BASE_URL+"/reports/companies_pdf?"+data;
	window.open(url, "companies_rep", "width=800,height=600");
	return false;
}