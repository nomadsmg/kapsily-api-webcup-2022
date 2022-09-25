<?php

namespace App\Dto\Security\Authentication;

use App\Core\Request\ArgumentResolver\AbstractRequestDTO;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints as Assert;

class LoginRequestInputDto extends AbstractRequestDTO
{
    #[Assert\NotBlank(allowNull: true)]
    #[Assert\Email()]
    public ?string $email = null;

    public function __construct(Request $request)
    {
        parent::__construct($request);

        $this->email = isset($this->payload['email']) ? $this->payload['email'] : null;
    }
}
