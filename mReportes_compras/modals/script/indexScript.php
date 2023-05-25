<!DOCTYPE html>
<html lang="es">
<head>
</head>
<body >
	<!--SCRIPT'S MERMAS POR CODIGO / CLAVE -->
	<script type="text/javascript">
		$('#departamento-MpC').select2({
			width: '100%',
			dropdownParent: $("#modal-MermasPorCodigo"),
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_departamentos.php",
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
		$('#familia-MpC').select2({
			width: '100%',
			dropdownParent: $("#modal-MermasPorCodigo"),
			placeholder: 'Seleccione una opcion',
			lenguage: 'es',
			minimumResultsForSearch: Infinity,
			ajax: {
				url: "consulta_familias.php",
				type: "post",
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						searchTerm: params.term // search term
					};
				},
				processResults: function(response) {
					return {
						results: response
					};
				},
				cache: true
			}
		});
	</script>
</body>
</html>