<?php

use App\PDOConnection;
use App\Table\PostTable;
use App\Table\UserTable;
use App\Table\CategoryTable;
use App\Table\CommentTable;

$pdo = PDOConnection::getPDO();
$id = $params['id'];
$slug = $params['slug'];

$post = (new PostTable($pdo))->find($id);
$author = (new UserTable($pdo))->find($post->getAuthorID())->getUsername();
$categories = (new CategoryTable($pdo))->getPostCategories($post->getID());
$commentTable = new CommentTable($pdo);

(new PostTable($pdo))->getPostMedias([$post]);

?>

<div class="heading-page header-text">
	<section class="page-heading">
		<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<div class="text-content">
					<h4>Admin - Post Details</h4>
				</div>
			</div>
		</div>
		</div>
	</section>
</div>

<section class="blog-posts grid-system">
	<div class="container">
		<div class="row">
			<div class="col-lg-12">
				<?php if(isset($_GET['update'])): ?>
					<div class="alert alert-success">
						Cet article a bien été modifié !
					</div>
				<?php endif ?>
				<div class="all-blog-posts">
					<div class="row">
						<div class="col-lg-12">
							<div class="blog-post">
								<div class="blog-thumb owl-carousel gallery-carousel">
									<?php foreach($post->getMedias() as $media): ?>
										<div class="item">
											<img class="gallery-img" src="/storage/post_images/<?= $media ?>" alt="Image article">
										</div>
									<?php endforeach ?>
								</div>
								<div class="down-content">
									<?php foreach($categories as $category): ?>
										<a href="<?= $router->url('category', ['id' => $category->getID(), 'slug' => $category->getSlug()]) ?>"><span><?= $category->getName() ?></span></a>, &nbsp;
									<?php endforeach ?>
									<h4><?= $post->getTitle() ?></h4>
									<ul class="post-info">
										<li><a href="#"><?= $author ?></a></li>
										<!-- <li><a href="#">Admin</a></li> -->
										<li><a href="#"><?= $post->getCreatedAt()->format('d F Y') ?></a></li>
										<!-- <li><a href="#">10 Comments</a></li> -->
									</ul>
									<div class="post-text-content">
										<?= nl2br($post->getContent()) ?>	
									</div>
									<div class="post-options">
										<div class="row">
											<div class="col-6">
												<a href="<?= $router->url('post_edit', ['id' => $post->getID()]) ?>" class="btn btn-secondary">Modifier</a>
											</div>
											<div class="col-6">
												<form action="<?= $router->url('post_delete', ['id'=> $post->getID()]) ?>" method="post" style="float: right" onsubmit="return confirm(`Voulez vous supprimer cet article ?`)">
													<button type="submit" class="btn btn-danger">Supprimer</button>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="sidebar-item comments">
								<div class="sidebar-heading">
									<?php $countComments = $commentTable->countForPost($post->getID()); ?>
									<h2><?= ($countComments === 0) ? "Aucun " : $countComments ?> <?= ($countComments > 1) ? "commentaires" : "commentaire" ?> </h2>
								</div>
								<div class="content">
									<ul>
										<?php if(empty($commentTable->getPostComments($post->getID()))): ?>
											<div class="right-content">
												<p>Aucun commmentaire pour cet article.</p>
											</div>
										<?php endif ?>
										<?php foreach($commentTable->getPostComments($post->getID()) as $comment): ?>
											<li>
												<div class="author-thumb">
													<img src="assets/images/comment-author-01.jpg" alt="">
												</div>
												<div class="right-content">
													<h4><?= $comment->getAuthorName() ?><span><?= $comment->getCreatedAt()->format('F d, Y')?></span></h4>
													<p><?= $comment->getContent() ?></p>
												</div>
											</li>
										<?php endforeach ?>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>