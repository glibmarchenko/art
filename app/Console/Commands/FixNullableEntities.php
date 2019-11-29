<?php

namespace App\Console\Commands;

use App\Models\Category;
use App\Models\DeliveryDetail;
use App\Models\Purchase;
use App\Models\PurchaseDetail;
use App\Models\Subscription;
use App\Models\Users\User;
use Illuminate\Console\Command;

/**
 * Class FixNullableEntities
 *
 * @package App\Console\Commands
 */
class FixNullableEntities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db-fix:nulls {type}';

    /**
     * @var
     */
    protected $table;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->table = $this->argument('type');
        $this->fixUserGalleries();
        $this->fixDeletePurchases();
        $this->fixDeletePurchaseDetails();
        $this->fixCategoryProduct();
        $this->fixDeliveryDetails();
        $this->fixSubscriptions();

        return;
    }

    /**
     * Fix Gallery relation in Users table
     */
    public function fixUserGalleries()
    {
        $collection = [];
        $users = User::whereNotNull('gallery_id')->get();

        foreach ($users as $user) {
            if (! $user->gallery) {
                $user->gallery_id = null;
                $user->save();
                $collection[] = ['name' => $user->name, 'id' => $user->id];
            }
        };

        $this->info('Nullable User Galleries updated');
        $this->info($this->table(['name', 'id'], $collection));
    }

    /**
     * Fix User, Product, Order, relation in Purchase table
     */
    public function fixDeletePurchases()
    {
        $collection = [];
        $purchases = Purchase::whereNotNull('order_id')->get();

        foreach ($purchases as $purchase) {
            $id = $purchase->id;
            if (! $purchase->user || ! $purchase->product || ! $purchase->order) {
                $purchase->delete();
                $collection[] = ['name' => $id, 'id' => $id];
            }
        };

        $this->info('Nullable Purchases deleted');
        $this->info($this->table(['name', 'id'], $collection));
    }

    /**
     * Fix Purchase relation in PurchaseDetail table
     */
    public function fixDeletePurchaseDetails()
    {
        $collection = [];
        $found = PurchaseDetail::whereNotNull('purchase_id')->get();

        foreach ($found as $item) {
            $id = $item->id;
            if (! $item->purchase) {
                $item->delete();
                $collection[] = ['name' => $id, 'id' => $id];
            }
        };

        $this->info('Wrong purchse details deleted');
        $this->info($this->table(['name', 'id'], $collection));
    }

    /**
     * Fix Product relation in Category table
     */
    public function fixCategoryProduct()
    {
        $collection = [];
        $found = Category::all();
        foreach ($found as $item) {
            $id = $item->id;
            if (! $item->product) {
                $item->delete();
                $collection[] = ['name' => $id, 'id' => $id];
            }
        };

        $this->info('Wrong caregory_product deleted');
        $this->info($this->table(['name', 'id'], $collection));
    }

    /**
     * Fix User relation in Delivery details table
     *
     */
    public function fixDeliveryDetails()
    {
        $collection = [];
        $found = DeliveryDetail::all();
        foreach ($found as $item) {
            $id = $item->id;
            if (! $item->user) {
                $item->delete();
                $collection[] = ['name' => $id, 'id' => $id];
            }
        };

        $this->info('Wrong Delivery details deleted');
        $this->info($this->table(['name', 'id'], $collection));
    }

    /**
     * Fix User Author relation in Subscriptions Table
     *
     */
    public function fixSubscriptions()
    {
        $collection = [];
        $found = Subscription::all();
        foreach ($found as $item) {
            $id = $item->id;
            if (! $item->user || ! $item->author) {
                $item->delete();
                $collection[] = ['name' => $id, 'id' => $id];
            }
        };

        $this->info('Wrong Subscriptions deleted');
        $this->info($this->table(['name', 'id'], $collection));
    }
}
