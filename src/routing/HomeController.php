<?php

namespace NotSymfony\routing;

use NotSymfony\core\App;
use NotSymfony\core\Request;
use NotSymfony\models\Coin;

class HomeController extends Controller
{
    public function __construct(App $app)
    {
        parent::__construct($app);
    }

    public function redirect()
    {
        if ($this->app->userPrivilegeLevel->name === "default") {
            header("Location: ./login");
            exit();
        }
        header("Location: ./home");
        exit();
    }

    public function home(Request $request)
    {
        $data = $this->getAllCryptoFromAPI();

        $this->router->showView("home", ["data" => $data]);
    }

    public function getCoinData(Request $request)
    {
        $coin_slug = $request->getURLVariable("coin");

        $data = $this->getCryptoFromAPI($coin_slug);
        $remaining_usd = $this->app->user->usd;

        if ($coin = Coin::findOne(["slug" => $coin_slug, "user_id" => $this->app->user->id])) {
            $this->router->showView(
                "coin",
                [
                    "coin" => $data,
                    "owned" => $coin->amount,
                    "remaining_usd" => $remaining_usd
                ]
            );
        } else {
            $this->router->showView(
                "coin",
                [
                    "coin" => $data,
                    "remaining_usd" => $remaining_usd
                ]
            );
        }
    }

    public function coinTransaction(Request $request): void
    {
        $coin_slug = $request->getURLVariable("coin");
        $amount = $request->getPOSTValue("amount");
        $value = $request->getPOSTValue("value");

        $coins_bought = $amount / $value;

        $this->app->user->usd -= $amount;
        $this->app->user->update();

        if ($coin = Coin::findOne(["slug" => $coin_slug, "user_id" => $this->app->user->id])) {
            $coin->amount = $coin->amount + $coins_bought;
            $coin->update();
        } else {
            $coin = new Coin();
            $coin->loadData(["slug" => $coin_slug, "user_id" => $this->app->user->id, "amount" => $coins_bought]);
            if ($coin->validate()) {
                $coin->save();
            }
        }


        header("Location: ./coin?coin=$coin_slug");
        exit();
    }

    public function getCryptoFromAPI(string $coin): array
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => "https://data.messari.io/api/v1/assets/$coin/metrics?fields=id,slug,symbol,market_data",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "cache-control: no-cache"
            ],
        ]);

        $response = curl_exec($curl);

        $responseData = json_decode($response, true);
        return $responseData["data"];
    }

    public function getAllCryptoFromAPI(): array
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://data.messari.io/api/v2/assets?fields=slug,symbol,metrics/market_data/price_usd",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "cache-control: no-cache"
            ],
        ]);

        $response = curl_exec($curl);

        $responseData = json_decode($response, true);
        return $responseData["data"];
    }

}