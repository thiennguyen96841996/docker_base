<?php
namespace App\Common\Log\Formatter;

use Illuminate\Log\Logger;
use Monolog\Formatter\LineFormatter;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;

/**
 * ログの基本フォーマットを設定するクラス。
 * @package \App\Common\Log
 */
class BasicFormatter
{
    /**
     * 出力するログ情報(全体)のフォーマットを取得する。
     * @return string
     */
    protected function getLogFormat(): string
    {
        $format = [
            'Date:%datetime%',
            'Uid:%extra.uid%',
            'Ip:%extra.ip%',
            'Level:%level_name%',
            'Where:%extra.class%<%extra.function%(%extra.line%)>',
            'Message:%message%',
            'Context:%context%'
        ];
        return join("\t", $format) . PHP_EOL;
    }

    /**
     * 出力するログ情報(日付)のフォーマットを取得する。
     * @return string
     */
    protected function getLogDateFormat(): string
    {
        return 'Y-m-d H:i:s:v';
    }

    /**
     * ログフォーマットをカスタマイズする。
     * ※ configファイルにて、'tap'項目にこのクラスを指定することで、
     *   インスタンス作成の際に\Illuminate\Log\LogManager::tap()から呼び出される。
     * @param  \Illuminate\Log\Logger $logger
     * @return void
     * @noinspection PhpPossiblePolymorphicInvocationInspection
     */
    public function __invoke(Logger $logger)
    {
        $formatter = new LineFormatter($this->getLogFormat(), $this->getLogDateFormat(), true, true);

        // Illuminateを除外することで出力場所、関数がNULLになることがあるので注意
        $introspection = new IntrospectionProcessor(\Monolog\Logger::DEBUG, [ 'Illuminate\\' ]);
        // 同一リクエストであるかを識別するためにランダムなIDをログにつける
        $uid = new UidProcessor();
        // IPをログに出す(他にも出せるものはある)
        $web = new WebProcessor();

        /** @var \Monolog\Logger $logger */
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($formatter);
            $handler->pushProcessor($introspection);
            $handler->pushProcessor($web);
            $handler->pushProcessor($uid);
        }
    }
}
