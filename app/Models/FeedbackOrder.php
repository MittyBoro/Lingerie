<?php

namespace App\Models;

use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackOrderSend;

class FeedbackOrder extends BaseModel
{

	protected $appends = [
		'form_name',
	];

	const FORM_TYPES = [
		'contact_us'      => 'Связаться с нами',
		'franchising'     => 'Стать франчайзи',
		'distributor'     => 'Стать дистрибьютором',
		'contract'        => 'Контрактное производство',
		'to_alevi_family' => 'Хочу в семью AleVi',

		'blog_subscribe'  => 'Подписаться на рассылку',
		'news_footer'     => 'Быть в курсе новостей',

		'popup_1'     => 'Всплывающее окно 1',
		'popup_2'     => 'Всплывающее окно 2',
	];

	public static function boot()
	{
		parent::boot();

		static::created( function($model)
		{
			$model->sendMailNotify();
		});
	}

    public function sendMailNotify()
    {
		// заявки на подписку, что-то с этим делаь другое
		if ( in_array($this->form, ['blog_subscribe','news_footer']) )
			return 'stop';

		$recipient = config('alevi.mail_to');

		Mail::to($recipient)->send(new FeedbackOrderSend($this));
    }

	public function getFormNameAttribute($val)
	{
		return self::FORM_TYPES[$this->form] ?? 'Прочее';
	}

	public static function canCreate($user_hash)
	{
		return !self::where('user_hash', $user_hash)
						->where('created_at', '>=', Carbon::now()->subMinutes(1))
						->exists();
	}
}
