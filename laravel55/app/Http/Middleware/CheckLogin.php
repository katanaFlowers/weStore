<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      $return_url = $_SERVER['HTTP_REFERER'];
      $member =  $request->session()->get('member','');
      if($member == '')
      {
        echo
        '<html>
        <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=0">
        <link rel="stylesheet" href="/css/weui.css">
        </head>
        <body>
        <div id="dialogs">
          <div class="js_dialog" id="androidDialog2">
              <div class="weui_mask"></div>
              <div class="weui_dialog weui_skin_android">
                  <div class="weui_dialog_bd" style="margin-top:20px;">
                      您还未登陆网站，点击登陆付款。
                  </div>
                  <div class="weui_dialog_ft">
                      <a href="javascript:history.back()" class="weui_btn_dialog default">取消</a>
                      <a href="/login?return_url='.urlencode($return_url).'" class="weui_btn_dialog primary">登陆</a>
                  </div>
              </div>
            </div>
           </div>
          </body>
         </html>';
         exit;
      }
        return $next($request);
    }
}
