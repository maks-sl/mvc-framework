<?php

/** @var \Framework\Renderer $this */
/** @var \App\Parser\ReadModel\TaskListItem[] $listItems */

$this->params['title'] = 'Tasks';
$this->extend('layout/main');

?>
<h1>Tasks</h1>

<div style="margin: 20px auto">
    <form method="post">
        <div class="form-group">
            <label for="form_url">Enter url to parsing</label>
            <input type="url" class="form-control" id="form_url" name="url" required="required" placeholder="Url">
        </div>
        <button type="submit" class="btn btn-primary">Parse</button>
    </form>
</div>

<table class="table">
    <thead>
    <tr>
        <th scope="col">#</th>
        <th scope="col">Url</th>
        <th scope="col">Num results</th>
        <th scope="col">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($listItems as $item) :?>
        <tr>
            <th scope="row"><?= $item->id ?></th>
            <td><?= $item->url ?></td>
            <td><?= $item->numResults ?></td>
            <td><a href="<?= $this->url('parser_view', ['id' => $item->id])?>">
                    <i class="glyphicon glyphicon-eye-open"></i> View
                </a></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>