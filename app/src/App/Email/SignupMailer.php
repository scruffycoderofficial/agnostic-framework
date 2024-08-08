<?php
/*
 * This file is part of the CoolStuff Enterprise Project.
 *
 * (c) Luyanda Siko <sikoluyanda@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

declare(strict_types=1);

namespace CoolStuff\App\Email;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mime\Address;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;

final class SignupMailer
{
    public function __construct(private TemplatedEmail $templatedEmail)
    {
    }

    public function sendWelcomeMessage(string $toEmail): TemplatedEmail
    {
        (new Email())
            ->to(new Address($toEmail))
            ->from('info@coolstuff-enteprise.com')
            ->subject('Thanks for signing for signing up!')->text('Thank you for signing up with us.')/*
            ->htmlTemplate('emails/signup.html.twig')
            ->textTemplate('emails/signup.html.twig')*/;

        return $this->templatedEmail;
    }
}
