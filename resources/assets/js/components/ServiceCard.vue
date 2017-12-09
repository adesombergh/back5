<template>
	<div class="card">
		<div class="card-header">
			<ul class="nav nav-pills card-header-pills">
				<li class="nav-item">
				<a class="nav-link active" href="#">Résumé</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" href="#">Caisse</a>
				</li>
				<li class="nav-item">
				<a class="nav-link" href="#">Horaires</a>
				</li>
			</ul>
		</div>
		<div class="card-body">
			<service-table></service-table>
		</div>
	</div>
</template>

<script>
	import ServiceTable from './ServiceTable.vue'

	export default {
		components : {
			ServiceTable
		}
	}

</script>