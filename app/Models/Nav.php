<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class Nav extends Model
{
    //
    protected $fillable=['name','pid','url','permission_id'];

    //获取权限的名字
    public function permission_name()
    {
        return $this->belongsTo(Permission::class,'permission_id','id');
    }

    //一级菜单有多个
    public function children()
    {
     return $this->hasMany(self::class,'pid','id');
    }

    //返回菜单的html
    public static function navHtml()
    {
        $html='';
      foreach(Nav::where('pid',0)->get() as $nav){

          $children_html='';
          if(Auth::user()->can($nav->permission_name->name)){

              foreach ($nav->children as $n){
                  $children_html.='<li><a href="'.url($n->url).'">'.$n->name.'</a></li>';
              }
          };

          if(empty($children_html)){
              //父的html没必要存在
           continue;
          }

          $html.='<li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true"
                       aria-expanded="false">'.$nav->name.'<span class="caret"></span></a><ul class="dropdown-menu">';

          $html.=$children_html;

          $html.='</ul>
                </li>';
      }
        return $html;
    }

}
