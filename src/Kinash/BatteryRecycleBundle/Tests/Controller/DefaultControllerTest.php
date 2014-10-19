<?php

namespace Kinash\BatteryRecycleBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class DefaultControllerTest extends WebTestCase
{
    protected $client;

    /**
     * prepare tests - Clean DB
     */
    public function setUp()
    {
        $this->client = static::createClient();
        //clear db
        $this->client->getContainer()->get('doctrine')->getRepository('BatteryRecycleBundle:BatteryPack')->truncate();
    }

    /**
     * Test Default Controller
     */
    public function testIndex()
    {
        $this->submitForm('AA', 4);
        $this->submitForm('AAA', 3);
        $this->submitForm('AA', 1);

        $this->client->request('GET', '/');
        $content =  $this->client->getResponse()->getContent();

        preg_match("%<tr><td>AA</td><td>(.*?)</td></tr>%", $content, $findAA);
        preg_match("%<tr><td>AAA</td><td>(.*?)</td></tr>%", $content, $findAAA);

        $this->assertEquals($findAA[1],5);
        $this->assertEquals($findAAA[1],3);
    }


    /** Submit form
     * @param $type
     * @param $count
     */
    protected function submitForm($type, $count)
    {
        $crawler = $this->client->request('GET', '/new');

        $form = $crawler->selectButton('battery_pack_form[save]')->form();
        $form->setValues(array(
            'battery_pack_form[type]' => $type,
            'battery_pack_form[count]' => $count,
            'battery_pack_form[name]' => 'test',
        ));
        $this->client->submit($form);
    }
}
