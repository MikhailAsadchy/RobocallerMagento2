<?php
namespace Devchannel\HelloWorld\Controller\Index;

use Devchannel\HelloWorld\Service\RCallerSender;

class Test extends \Magento\Framework\App\Action\Action
{
    protected $_pageFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $pageFactory)
    {
        $this->_pageFactory = $pageFactory;
        return parent::__construct($context);
    }

    public function execute()
    {
        $data = array(
            'price' => '0.5',
            'entries' => 'Роллтон 1 шт.',
            'customerAddress' => 'г. Минск, ул. Независимости, д.1',
            'customerPhone' => '+375297189587',
            'customerName' => 'Павлов Михаил Павлович',
            'priceCurrency' => 'руб.');
        $sender = new RCallerSender(); // inject dependency
        $sender->sendOrderToRCallerInternal($data);
    }


}