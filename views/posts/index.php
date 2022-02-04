<?php

use App\Helpers\Text;
use App\Models\Post;
use App\PDOConnection;

$pdo = PDOConnection::getPDO();
$limit = 10;
$postCount = (int)$pdo->query('SELECT count(id) FROM post')->fetch()[0];
$pages = ceil($postCount / $limit);
$currentPage = isset($_GET['page'])? (int)$_GET['page'] : 1;
if($currentPage < 0 ) {
	throw new Exception("La page n'existe pas");
}
$offset = ($currentPage - 1) * $limit;
$postList = $pdo->query("SELECT * FROM post LIMIT $limit OFFSET $offset")->fetchAll(PDO::FETCH_CLASS, Post::class);
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
						<?php foreach($postList as $post): ?>
							<div class="col-lg-6" style="display: flex">
								<div class="blog-post" style="display: flex; flex-direction: column;">
									<!-- <div class="blog-thumb">
										<img src="assets/images/blog-thumb-01.jpg" alt="">
									</div> -->
									<div class="down-content" style="flex-grow: 1">
										<!-- <span>Lifestyle</span> -->
										<a href="post-details.html"><h4><?= $post->getTitle() ?></h4></a>
										<ul class="post-info">
											<!-- <li><a href="#">Admin</a></li> -->
											<li><a href="#"><?= $post->getCreatedAt()->format('d F Y') ?></a></li>
											<!-- <li><a href="#">12 Comments</a></li> -->
										</ul>
										<p><?= Text::excerpt(nl2br($post->getContent()), 100) ?></p>
										<div class="post-options">
											<div class="row">
											<div class="col-lg-12">
												<ul class="post-tags">
												<li><i class="fa fa-tags"></i></li>
												<li><a href="#">Best Templates</a>,</li>
												<li><a href="#">TemplateMo</a></li>
												</ul>
											</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach ?>
						<div class="col-lg-12">
							<ul class="page-numbers">
								<?php if($currentPage > 1): ?>
									<?php 
									$link = $router->url('posts');
									if($currentPage > 2) $link .= '?page=' . $currentPage - 1;
									?>
									<li><a href="<?= $link ?>"><i class="fa fa-angle-double-left"></i></a></li>
								<?php endif?>
								<?php
									for($i =  1; $i<= $pages; $i++ ) {
										$link = ($i === 1) ? $router->url('posts'): $router->url('posts'). '?page=' .$i;
										$active = ($i === $currentPage) ? "active" : "";
										echo <<<HTML
											<li class="$active"><a href="{$link}">$i</a></li>
										HTML;
									}
								?>
								<?php if($currentPage < $pages): ?>
									<li><a href="?page=<?= $currentPage + 1 ?>"><i class="fa fa-angle-double-right"></i></a></li>
								<?php endif?>
							</ul>
						</div>
					</div>
				</div>
			</div>
			<div class="col-lg-4">
				<div class="sidebar">
					<div class="row">
						<div class="col-lg-12">
						<div class="sidebar-item search">
							<form id="search_form" name="gs" method="GET" action="#">
							<input type="text" name="q" class="searchText" placeholder="type to search..." autocomplete="on">
							</form>
						</div>
						</div>
						<div class="col-lg-12">
						<div class="sidebar-item recent-posts">
							<div class="sidebar-heading">
							<h2>Recent Posts</h2>
							</div>
							<div class="content">
							<ul>
								<li><a href="post-details.html">
								<h5>Vestibulum id turpis porttitor sapien facilisis scelerisque</h5>
								<span>May 31, 2020</span>
								</a></li>
								<li><a href="post-details.html">
								<h5>Suspendisse et metus nec libero ultrices varius eget in risus</h5>
								<span>May 28, 2020</span>
								</a></li>
								<li><a href="post-details.html">
								<h5>Swag hella echo park leggings, shaman cornhole ethical coloring</h5>
								<span>May 14, 2020</span>
								</a></li>
							</ul>
							</div>
						</div>
						</div>
						<div class="col-lg-12">
						<div class="sidebar-item categories">
							<div class="sidebar-heading">
							<h2>Categories</h2>
							</div>
							<div class="content">
							<ul>
								<li><a href="#">- Nature Lifestyle</a></li>
								<li><a href="#">- Awesome Layouts</a></li>
								<li><a href="#">- Creative Ideas</a></li>
								<li><a href="#">- Responsive Templates</a></li>
								<li><a href="#">- HTML5 / CSS3 Templates</a></li>
								<li><a href="#">- Creative &amp; Unique</a></li>
							</ul>
							</div>
						</div>
						</div>
						<div class="col-lg-12">
						<div class="sidebar-item tags">
							<div class="sidebar-heading">
							<h2>Tag Clouds</h2>
							</div>
							<div class="content">
							<ul>
								<li><a href="#">Lifestyle</a></li>
								<li><a href="#">Creative</a></li>
								<li><a href="#">HTML5</a></li>
								<li><a href="#">Inspiration</a></li>
								<li><a href="#">Motivation</a></li>
								<li><a href="#">PSD</a></li>
								<li><a href="#">Responsive</a></li>
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
