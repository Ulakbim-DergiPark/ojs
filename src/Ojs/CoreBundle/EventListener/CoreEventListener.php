<?php

namespace Ojs\CoreBundle\EventListener;

use FOS\UserBundle\Model\UserInterface;
use Ojs\CoreBundle\Events\CoreEvent;
use Ojs\CoreBundle\Event\CoreEvents;
use Ojs\UserBundle\Entity\User;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Doctrine\ORM\EntityManager;

class CoreEventListener implements EventSubscriberInterface
{
    /** @var \Swift_Mailer */
    private $mailer;

    /** @var string */
    private $mailSender;

    /** @var string */
    private $mailSenderName;

    /** @var RouterInterface */
    private $router;

    /** @var EntityManager */
    private $em;

    /**
     * @param RouterInterface $router
     * @param \Swift_Mailer   $mailer
     * @param EntityManager   $em
     * @param string          $mailSender
     * @param string          $mailSenderName
     *
     */
    public function __construct(
        RouterInterface $router,
        \Swift_Mailer $mailer,
        EntityManager   $em,
        $mailSender,
        $mailSenderName
    ) {
        $this->router = $router;
        $this->mailer = $mailer;
        $this->em = $em;
        $this->mailSender = $mailSender;
        $this->mailSenderName = $mailSenderName;
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            CoreEvents::OJS_INSTALL_BASE => 'onInstallBase',
            CoreEvents::OJS_INSTALL_3PARTY => 'onInstall3Party',
            CoreEvents::OJS_UPLOAD_FILE => 'onUploadFile',
            CoreEvents::OJS_CROP_FILE => 'onCropFile',
            CoreEvents::OJS_ELASTICA_REQUEST => 'onElasticaRequest'
        );
    }

    /**
     * @param CoreEvent $event
     */
    public function onInstallBase(CoreEvent $event)
    {

    }

    /**
     * @param CoreEvent $event
     */
    public function onInstall3Party(CoreEvent $event)
    {

    }

    /**
     * @param CoreEvent $event
     */
    public function onUploadFile(CoreEvent $event)
    {

    }

    /**
     * @param CoreEvent $event
     */
    public function onCropFile(CoreEvent $event)
    {

    }

    /**
     * @param CoreEvent $event
     */
    public function onElasticaRequest(CoreEvent $event)
    {

    }

    /**
     * @return \Doctrine\Common\Collections\Collection | User[]
     * @link http://stackoverflow.com/a/16692911
     */
    private function getAdminUsers()
    {
        $qb = $this->em->createQueryBuilder();
        $qb->select('u')
            ->from('OjsUserBundle:User', 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%ROLE_SUPER_ADMIN%')
        ;

        return $qb->getQuery()->getResult();
    }

    /**
     * @param UserInterface $user
     * @param string $subject
     * @param string $body
     */
    private function sendMail(UserInterface $user, $subject, $body)
    {
        $message = $this->mailer->createMessage();
        $to = array($user->getEmail() => $user->getUsername());
        $message = $message
            ->setSubject($subject)
            ->addFrom($this->mailSender, $this->mailSenderName)
            ->setTo($to)
            ->setBody($body, 'text/html');
        $this->mailer->send($message);
    }
}