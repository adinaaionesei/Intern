<?php

namespace Intern\Vendor\Model\Api\Data;
interface VendorInterface
{
    public function getId();

    public function setId($id);

    public function getName();

    public function setName($name);

    public function getStatus();

    public function setStatus($status);

    public function getEmail();

    public function setEmail($email);
}
