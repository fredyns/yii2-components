<?php
/**
 * @var yii\web\View $this
 */
$alertTypes = ['success', 'info', 'warning', 'danger', 'error' => 'danger'];

echo <<<HTML
    <div class="row">
        <div class="col-xs-12">
\n
HTML;

foreach ($alertTypes as $name => $cssClass)
{
    if (is_integer($name))
    {
        $name = $cssClass;
    }

    $alert = Yii::$app->session->getFlash($name);

    if (empty($alert))
    {
        continue;
    }

    if (is_scalar($alert))
    {
        $message = $alert;
    }
    elseif (is_array($alert))
    {
        $message = implode("\n<br/>\n", $alert);
    }
    else
    {
        $message = print_r($alert, true);
    }

    echo <<<HTML
    <div class="alert alert-{$cssClass} alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
        {$message}
    </div>\n
HTML;
}

echo <<<HTML
        </div>
    </div>
\n
HTML;
