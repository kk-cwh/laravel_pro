<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use \Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $productList = DB::table('product')->join('cate', 'product.cateId', '=', 'cate.id')
            ->select('product.id', 'product.name', 'product.price', 'product.onSale', 'cate.id as cateId', 'cate.name as cateName')->orderBy('product.id','DESC')->paginate(10);
//        return response()->json($productList);
        return view('product', ['data' => ['title' => '商品列表', 'productList' => $productList]]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cateList = DB::table('cate')->select('id', 'name')->get();
        return view('product_add', ['data' => ['title' => '商品新增', 'cateList' => $cateList]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $imgUploadArr = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $info = getimagesize($file);
                if ($info) {
                    if ($file->getClientSize() > 2097152) {
                        return response()->json(['success' => false, 'reason' => '上传的图片不能超过2M']);
                    }
                    $saveName = $this->createRandomStr(20) . '.' . $file->guessClientExtension();
                    $file->move('./uploads/', $saveName);
                    $imgUploadArr[] = '/uploads/' . $saveName;
                } else {
                    return response()->json(['success' => false, 'reason' => '上传的不是图片文体']);
                }

            }
        }

        $cateId = $request->get('cateId');
        $cate = DB::table('cate')
            ->where('id', $cateId)->first();
        if (!$cate) {
            return response()->json(['success' => false, 'reason' => '商品分类不存在']);
        }
        $inputs = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'cateId' => $request->get('cateId'),
            'onSale' => $request->get('onSale')
        ];
        $rules = ['name' => 'required|string', 'price' => 'required|integer', 'cateId' => 'required|integer', 'onSale' => 'in:1,0'];
        $messages = [
            'required' => ':attribute  field is required . ',
            'string' => ':attribute  field is required string . ',
            'number' => ':attribute  field is required number . ',
        ];
        $attributes = ['name' => '姓名', 'price' => '价格', 'cateId' => '类别id', 'onSale' => '是否上架'];

        $validator = Validator::make($inputs, $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'reason' => $validator->messages()->first()]);
        }
        DB::beginTransaction();
        try {
            $productId = DB::table('product')->insertGetId(['name' => $inputs['name'], 'price' => $inputs['price'], 'cateId' => $inputs['cateId'], 'onSale' => $inputs['onSale'], 'updated_at' => time(), 'created_at' => time()]);
            if ($imgUploadArr) {
                foreach ($imgUploadArr as $imgUrl) {
                    DB::table('album')->insert([
                        'productId' => $productId,
                        'urlStr' => $imgUrl
                    ]);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            foreach ($imgUploadArr as $imgUrl) {
                @unlink('.' . $imgUrl);
            }
            return response()->json(['success' => false, 'reason' => 'sorry,系统繁忙!']);
        }
        DB::commit();
        return response()->json(['success' => true, 'reason' => '']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $product = DB::table('product')
            ->join('cate', 'product.cateId', '=', 'cate.id')
            ->select('product.id', 'product.name', 'product.price', 'product.onSale', 'cate.id as cateId', 'cate.name as cateName')->where('product.id', $id)->first();

        $cateList = DB::table('cate')->select('id', 'name')->get();
        $albumList = DB::table('album')->select('id', 'productId', 'urlStr')->where('productId', $id)->get();
        return view('product_edit', ['data' => ['title' => '编辑商品', 'product' => $product, 'albumList' => $albumList, 'cateList' => $cateList]]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = DB::table('product')
            ->join('cate', 'product.cateId', '=', 'cate.id')->select('product.id', 'product.name', 'product.price', 'product.onSale', 'cate.id as cateId', 'cate.name as cateName')->where('product.id', $id)->first();
        if (!$product) {
            return response()->json(['success' => false, 'reason' => '商品不存在']);
        }
        $inputs = [
            'name' => $request->get('name'),
            'price' => $request->get('price'),
            'cateId' => $request->get('cateId'),
            'onSale' => $request->get('onSale'),
        ];
        $rules = ['name' => 'required|string', 'price' => 'required|integer', 'cateId' => 'required|integer', 'onSale' => 'in:0,1'];
        $messages = [
            'required' => ':attribute  field is required . ',
            'string' => ':attribute  field is required string . ',
            'integer' => ':attribute  field is required number . ',
            'in' => ':attribute  field is required 0,1. ',
        ];
        $attributes = ['name' => '姓名', 'price' => '价格', 'cateId' => '类别id', 'onSale' => '是否上架'];

        $validator = Validator::make($inputs, $rules, $messages, $attributes);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'reason' => $validator->messages()->first()]);
        }
        $res = DB::table('product')->where('id', $id)->update(['name' => $inputs['name'], 'price' => $inputs['price'], 'cateId' => $inputs['cateId'], 'onSale' => $inputs['onSale'], 'updated_at' => time()]);

        return response()->json(['success' => true, 'reason' => $res]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createRandomStr($length)
    {
        $str = array_merge(range(0, 9), range('a', 'z'), range('A', 'Z'));
        shuffle($str);
        $str = implode('', array_slice($str, 0, $length));
        return $str;
    }
}
