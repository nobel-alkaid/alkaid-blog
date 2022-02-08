<?php

use App\Helpers\Text;
use App\Helpers\URL;
use App\Models\Category;
use App\Models\Post;
use App\PaginatedQuery;
use App\PDOConnection;
use App\Table\CategoryTable;
use App\Table\PostTable;

$pdo = PDOConnection::getPDO();

[$posts, $paginatedQuery] = (new PostTable($pdo))->getPostsWithPagination();
(new CategoryTable($pdo))->hydratePosts($posts);

$link = $router->url('posts');
?>
<!-- Page Content -->
<!-- Banner Starts Here -->
<div class="heading-page header-text">
	<section class="page-heading">
		<div class="container">
		<div class="row">
			<div class="col-lg-12">
			<div class="text-content">
				<h4>Recent Posts</h4>
				<h2>Our Recent Blog Entries</h2>
			</div>
			</div>
		</div>
		</div>
	</section>
</div>

<!-- Banner Ends Here -->

<section class="call-to-action">
	<div class="container">
		<div class="row">
		<div class="col-lg-12">
			<div class="main-content">
			<div class="row">
				<div class="col-lg-8">
				<span>Stand Blog HTML5 Template</span>
				<h4>Creative HTML Template For Bloggers!</h4>
				</div>
				<div class="col-lg-4">
				<div class="main-button">
					<a href="https://templatemo.com/tm-551-stand-blog" target="_parent">Download Now!</a>
				</div>
				</div>
			</div>
			</div>
		</div>
		</div>
	</div>
</section>


<section class="blog-posts grid-system">
	<div class="container">
		<div class="row">
			<div class="col-lg-8">
				<div class="all-blog-posts">
					<div class="row" style="align-items: stretch">
						<?php foreach($posts as $post): ?>
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

