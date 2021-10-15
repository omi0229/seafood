<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gregwar\Captcha\CaptchaBuilder;
use Gregwar\Captcha\PhraseBuilder;

class AuthController extends Controller
{
    /**
     * 取得驗證碼
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCaptcha()
    {
        $phraseBuilder = new PhraseBuilder(5, '0123456789');
        $builder = new CaptchaBuilder(null, $phraseBuilder);
        $builder->setBackgroundColor(245, 245, 245);
        $builder->build(110, 28);
        # 獲取驗證碼內容
        $phrase = $builder->getPhrase();
        # 清除緩存
        ob_clean();
        return response()->Json(['image' => $builder->inline(), 'answers' => $phrase]);
    }
}
