<?php

use App\PDOConnection;
use App\Table\CategoryTable;

$pdo = PDOConnection::getPDO();
$categories = (new CategoryTable($pdo))->getElements();

?>

<div class="heading-page header-text">
	<section class="page-heading">
		<div class="container">
		<div class="row">
			<div class="col-lg-12">
			<div class="text-content">
				<h4>Categories</h4>
				<h2>Les différentes catégories</h2>
			</div>
			</div>
		</div>
		</div>
	</section>
</div>

<div class="container" style="margin-top: 70px">
	<?php if(isset($_GET['delete'])): ?>
		<div class="alert alert-success">
			L'enregistement a bien été supprimé !
		</div>
	<?php endif ?>
	<?php if(isset($_GET['update'])): ?>
		<div class="alert alert-success">
			L'enregistement a bien été modifié !
		</div>
	<?php endif ?>
	<div class="col-lg-12">
		<table class="table">
		<thead>
			<tr>
				<th scope="col">ID</th>
				<th scope="col">Titre</th>
				<th scope="col">Slug</th>
				<th scope="col"><a href="<?= $router->url('category_create') ?>" class="btn btn-primary">Ajouter</a></th>
			</tr>
		</thead>
		<tbody>
		<?php foreach($categories as $category): ?>
			<tr>
				<th scope="row">#<?= $category->getID() ?></th>
				<td style="text-transform: capitalize"><em><?= $category->getName() ?></em></td>
				<td><i><?= $category->getSlug() ?></i></td>
				<td>
					<a href="<?= $router->url('category_edit', ['id' => $category->getID()]) ?>" class="btn btn-info">Modifier</a>
					<form action="<?= $router->url('category_delete', ['id' => $category->getID()]) ?>" method="post" onsubmit="confirm(`Voulez vous supprimer cet element ?`)" style="display: inline">
						<button type="submit" class="btn btn-danger">Supprimer</button>
					</form>
				</td>
			</tr>
		<?php endforeach ?>
			
		</tbody>
		</table>
	</div>
</div>