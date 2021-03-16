<?php

/** @var \Framework\Renderer $this */
/** @var \App\Parser\ReadModel\Result[] $results */
/** @var \App\Parser\ReadModel\Task $task */
/** @var \App\Widgets\Pagination $pagination */

$this->params['title'] = 'Task '.$task->id.' - Results';
$this->extend('layout/main');

$current = $pagination->getPage();
$pagesCount = $pagination->getPagesCount();

?>
<h1>Results</h1>
<p><?=$task->url?></p>

<?php foreach ($results as $result) :?>
    <div class="panel panel-default">
        <div class="panel-heading">
            <span class="pull-right"><?= $result->price ?></span>
            <a href="#"><?= $result->name ?></a>
        </div>
        <div class="panel-body">
            <img style="width: 100px; float: left" src="<?= $result->image ?>">
            <div style="margin: 20px auto auto 120px">
                <p><?= $result->description ?></p>
                <i style="font-size: smaller"><?= $result->url ?></i>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if ($pagesCount > 0): ?>
    <ul class="pagination">
        <?php for ($page=1; $page <= $pagesCount; $page++): ?>
            <li class="page-item<?= ($page == $current) ? ' active' : ''?>">
                <a class="page-link" href="<?= $this->url('parser_view_page', ['id' => $task->id, 'page'=>$page]) ?>"><?= $page ?></a>
            </li>
        <?php endfor; ?>
    </ul>
<?php endif; ?>