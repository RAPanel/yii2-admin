<?php
/**
 * Created by PhpStorm.
 * User: semyonchick
 * Date: 26.05.2015
 * Time: 11:12
 */
use yii\helpers\Html;

?>


<div class="row">
    <div class="column">

        <table style="width: 100%">
            <tr>
                <th>URL</th>
                <th>Description</th>
            </tr>

            <?php foreach ($actions as $url => $description): ?>

                <tr>
                    <td>
                        <strong><?= Html::a($url, [$url]) ?></strong>
                    </td>
                    <td>
                        <?= $description ?>
                    </td>
                </tr>

            <?php endforeach; ?>

        </table>

    </div>

</div>
