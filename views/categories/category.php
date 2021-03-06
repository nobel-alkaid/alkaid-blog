<?php

use App\Helpers\URL;
use App\Models\Post;
use App\Helpers\Text;
use App\PDOConnection;
use App\PaginatedQuery;
use App\Models\Category;
use App\Table\PostTable;
use App\Table\UserTable;
use App\Table\CommentTable;
use App\Table\CategoryTable;

$pdo = PDOConnection::getPDO();
$id = $params['id'];
$slug = $params['slug'];

$categoryTable = new CategoryTable($pdo);
$showCategory = $categoryTable->find($id);

[$posts, $paginatedQuery] = (new PostTable($pdo))->getPostsWithPaginationFromCategory($showCategory->getID());
(new CategoryTable($pdo))->hydratePosts($posts);
(new PostTable($pdo))->getPostMedias($posts);

$categorySlug = $showCategory->getSlug();
$url = $router->url('category', ['id' => $showCategory->getID(), 'slug' => $showCategory->getSlug()]);
URL::handleSlugInURL($slug, $categorySlug, $url);

$link = $url;
$title = 'Categorie';
?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
	<section class="page-heading">
		<div class="container">
		<div class="row">
			<div class="col-lg-12">
			<div class="text-content">
				<h4>Catégorie</h4>
				<h2><?= $showCategory->getName() ?></h2>
			</div>
			</div>
		</div>
		</div>
	</section>
</div>

<!-- Banner Ends Here -->

<?php require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements/search-bar.php' ?>

<section class="blog-posts grid-system">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="all-blog-posts">
					<div class="row" style="align-items: stretch">
						<?php foreach($posts as $post): ?>
							<?php 
								$author = (new UserTable($pdo))->find($post->getAuthorID())->getUsername();
								$countComments = (new CommentTable($pdo))->countForPost($post->getID());
							?>
							<?php require 'card.php' ?>
						<?php endforeach ?>
						<div class="col-lg-12">
							<ul class="page-numbers">
								<?= $paginatedQuery->previousLink($link) ?>
								<?= $paginatedQuery->pageLinks($link) ?>
								<?= $paginatedQuery->nextLink($link) ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<?php require dirname(__DIR__) . DIRECTORY_SEPARATOR . 'elements/sidebar.php' ?>
		</div>
	</div>
</section>

