<?php
require '../../vendor/autoload.php';
use ClickClack\ClickClack\Model\Message;

function get(int $id): array
{
    return Message::selectAll($id);
}