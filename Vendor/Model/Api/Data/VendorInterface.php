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

    public function getTelephone();

    public function setTelephone($telephone);

    public function getCurrency();

    public function setCurrency($currency);

    public function getNotifyOrders();

    public function setNotifyOrders($notifyOrders);

    public function getCcEmails();

    public function setCcEmails($ccEmails);

}
