<?php

use App\Helpers\Text;

?>
<div class="col-lg-6" style="display: flex">
								<div class="blog-post" style="display: flex; flex-direction: column;">
									<div class="blog-thumb">
										<img src="storage/post_images/<?= $post->getMedias()[0] ?>" alt="Image d'article">
									</div>
									<div class="down-content" style="flex-grow: 1">
										<?php $firstCategory = $post->getCategories()[0]; ?>
										<a href="<?= $router->url('category', ['id'=> $firstCategory->getID(), 'slug' => $firstCategory->getSlug()]) ?>"><span><?= $firstCategory->getName() ?></span></a>
										<a href="<?= $router->url('post', ['id'=> $post->getID(), 'slug'=>$post->getSlug()]) ?>"><h4 class="post-title"><?= $post->getTitle() ?></h4></a>
										<ul class="post-info">
											<li><a href="#"><?= $author ?></a></li>
											<li><a href="#"><?= $post->getCreatedAt()->format('d F Y') ?></a></li>
											<?php if($countComments > 0): ?>
												<li><a href="#"><?= $countComments ?> <?= ($countComments > 1) ? "Commentaires" : "Commentaire" ?></a></li>
											<?php endif ?>
										</ul>
										<div class="post-text-content">
											<?= nl2br(Text::excerpt($post->getContent(), 170)) ?>
										</div>
									</div>
								</div>
							</div>