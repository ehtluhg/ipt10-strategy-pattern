<?php

namespace Strategy;

use Strategy\Cart\Item;
use Strategy\Cart\ShoppingCart;
use Strategy\Order\Order;
use Strategy\Invoice\TextInvoice;
use Strategy\Invoice\PDFInvoice;
use Strategy\Customer\Customer;
use Strategy\Payments\CashOnDelivery;
use Strategy\Payments\CreditCardPayment;
use Strategy\Payments\PaypalPayment;

class Application
{
    public static function run()
    {
        $iphone = new Item('IPH', 'iPhone', 'iPhone 14 Pro Max', 60000);
        $ipad = new Item('IPAD', 'iPad', 'iPad Pro M2', 20000);
        $watch = new Item('WATCH', 'Apple Watch', 'Apple Watch Ultra', 30000);

        $cart1 = new ShoppingCart();
        $cart1->addItem($iphone, 4);
        $cart1->addItem($watch, 1);

        $customer = new Customer('Gabriel Dy', 'Purok 5, Pulung Cacutud Angeles City', 'mangune.jello@auf.edu.ph');
        
        $order = new Order($customer, $cart1);

        $text_invoice = new TextInvoice();
        $order->setInvoiceGenerator($text_invoice);
        $text_invoice->generate($order);

        $cash_on_delivery = new CashOnDelivery($customer);
        $order->setPaymentMethod($cash_on_delivery);
        $order->payInvoice();
        
        echo "\n ============================== \n\n";

        $cart2 = new ShoppingCart();
        $cart2->addItem($ipad,2);
        $cart2->addItem($iphone,3);
        $cart2->addItem($watch,1);

        $order2 = new Order($customer, $cart2);

        $pdf_invoice = new PDFInvoice();
        $order2->setInvoiceGenerator($pdf_invoice);
        $pdf_invoice->generate($order2);

        $paypal_payment = new PaypalPayment('dygabriel31@gmail.com', 'ehtluhg');
        $order2->setPaymentMethod($paypal_payment);
        $order2->payInvoice();

        echo "\n ============================== \n\n";

        $customer2 = new Customer('John Doe', '170 Balasticio, Turo Magalang', 'doe.john@auf.edu.ph');

        $cart3 = new ShoppingCart();
        $cart3->addItem($iphone, 2);
        $cart3->addItem($ipad, 4);

        $order3 = new Order($customer2, $cart3);
        $order3->setInvoiceGenerator($text_invoice);
        $text_invoice->generate($order3);

        $credit_card_payment = new CreditCardPayment('Rhobert Dy', '33333333', '1414', '01/80');
        $order3->setPaymentMethod($credit_card_payment);
        $order3->payInvoice();
    }
}