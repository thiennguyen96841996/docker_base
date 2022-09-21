<?php
namespace GLC\Platform\Log\Formatters;

use Monolog\Formatter\LineFormatter;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;

/**
 * アプリケーションから出力されるログの基本フォーマットを設定するクラス。
 *
 * @package GLC\Platform\Log\Formatter
 * @author  TinhNC <tinhhang22@gmail.com>
 */
class BasicFormatter
{
    /**
     * 出力するログ情報(全体)のフォーマットの定義。
     * @var string
     */
    const LOG_BASIC_FORMAT = '[%datetime%] [%level_name%] %extra.class% <%extra.function%(%extra.line%)> %message% %context%' . PHP_EOL;

    /**
     * 出力するログ情報(日付)のフォーマットの定義。
     * @var string
     */
    const LOG_BASIC_DATE_FORMAT = 'Y-m-d H:i:s:v';

    /**
     * 出力するログ情報(全体)のフォーマットを取得する。
     *
     * @return string
     */
    protected function getLogFormat(): string
    {
        return self::LOG_BASIC_FORMAT;
    }

    /**
     * 出力するログ情報(日付)のフォーマットを取得する。
     *
     * @return string
     */
    protected function getLogDateFormat(): string
    {
        return self::LOG_BASIC_DATE_FORMAT;
    }

    /**
     * Loggerオブジェクトの設定をカスタマイズする。
     *
     * configファイルにて、'tap'項目にこのクラスを指定することで、
     * インスタンス作成の際に\Illuminate\Log\LogManager::tap()から呼び出される。
     *
     * @param  \Illuminate\Log\Logger $logger Loggerオブジェクト
     * @return void
     */
    public function __invoke($logger)
    {
        $formatter     = new LineFormatter($this->getLogFormat(), $this->getLogDateFormat(), true, true);
        $introspection = new IntrospectionProcessor(\Monolog\Logger::DEBUG, [ 'Illuminate\\' ]);
        $web           = new WebProcessor();

        /** @var \Monolog\Logger $logger */
        foreach ($logger->getHandlers() as $handler) {
            $handler->setFormatter($formatter);
            $handler->pushProcessor($introspection);
            $handler->pushProcessor($web);
        }
    }
}