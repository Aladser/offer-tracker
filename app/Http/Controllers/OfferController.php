<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\AdvertiserProduct;
use App\Models\Offer;
use App\Models\OfferSubscription;
use App\Models\OfferTheme;

class OfferController extends Controller
{
    /** Показать форму создания нового ресурса.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return 'create';
    }

    /** Сохраните вновь созданный ресурс в хранилище.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        // поиск имени
        $isOfferName = !is_null(Offer::getOfferName($data['name']));
        if ($isOfferName) {
            return ['result' => 0, 'error' => 'Название оффера уже занято'];
        } else {
            // поиск пользователя
            $userId = User::getUserId($data['user']);
            if (is_null($userId)) {
                return ['result' => 0, 'error' => "Пользователь {$data['user']} не существует"];
            } else {
                return Offer::add($data, $userId);
            }
        }
    }

    /** Отобразить указанный ресурс.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return 'show';
    }

    /** Показать форму редактирования указанного ресурса.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return 'edit';
    }

    /** Обновите указанный ресурс в хранилище.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        return 'update';
    }

    /** Удалить указанный ресурс из хранилища.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Offer::remove($id);
    }

    /** установить статус */
    public function status(Request $request)
    {
        $status = $request->all()['status']; 
        $id = $request->all()['id'];
        return Offer::setStatus($id, $status);
    }
}
