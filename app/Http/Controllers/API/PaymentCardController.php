<?php
// app/Http/Controllers/API/PaymentCardController.php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\PaymentCard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class PaymentCardController extends Controller
{
    /**
     * عرض جميع بطاقات المستخدم
     */
    public function index()
    {
        $user = Auth::user();
        $cards = $user->paymentCards()
            ->orderBy('is_default', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        // إخفاء البيانات الحساسة
        $formattedCards = $cards->map(function ($card) {
            return [
                'id' => $card->id,
                'card_type' => $card->card_type,
                'last_four' => $card->last_four,
                'cardholder_name' => $card->cardholder_name,
                'expiry_date' => $card->expiry_month . '/' . $card->expiry_year,
                'is_default' => $card->is_default,
                'created_at' => $card->created_at
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $formattedCards
        ]);
    }

    /**
     * إضافة بطاقة جديدة
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'card_number' => 'required|string|min:16|max:19',
            'cardholder_name' => 'required|string|max:100',
            'expiry_month' => 'required|string|size:2',
            'expiry_year' => 'required|string|size:4',
            'cvv' => 'required|string|min:3|max:4',
            'is_default' => 'boolean'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // TODO: هنا يجب استخدام خدمة الدفع (مثل Stripe) لإنشاء token
        // هذا مثال محاكاة
        $cardNumber = $request->card_number;
        $lastFour = substr($cardNumber, -4);
        $cardType = $this->detectCardType($cardNumber);

        // في الواقع يجب إرسال البيانات لبوابة الدفع والحصول على token
        $token = 'card_' . Str::random(32);

        // إذا كانت البطاقة ستكون افتراضية، نزيل العلامة من الآخرين
        if ($request->is_default) {
            $user->paymentCards()->update(['is_default' => false]);
        }

        $card = $user->paymentCards()->create([
            'card_type' => $cardType,
            'last_four' => $lastFour,
            'cardholder_name' => $request->cardholder_name,
            'expiry_month' => $request->expiry_month,
            'expiry_year' => $request->expiry_year,
            'token' => $token,
            'is_default' => $request->is_default ?? false
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة البطاقة بنجاح',
            'data' => [
                'id' => $card->id,
                'card_type' => $card->card_type,
                'last_four' => $card->last_four,
                'is_default' => $card->is_default
            ]
        ], 201);
    }

    /**
     * تعيين بطاقة كافتراضية
     */
    public function setDefault($id)
    {
        $user = Auth::user();
        $card = $user->paymentCards()->find($id);

        if (!$card) {
            return response()->json([
                'success' => false,
                'message' => 'البطاقة غير موجودة'
            ], 404);
        }

        // جعل جميع البطاقات غير افتراضية
        $user->paymentCards()->update(['is_default' => false]);

        // جعل البطاقة المحددة افتراضية
        $card->update(['is_default' => true]);

        return response()->json([
            'success' => true,
            'message' => 'تم تعيين البطاقة كافتراضية'
        ]);
    }

    /**
     * حذف بطاقة
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $card = $user->paymentCards()->find($id);

        if (!$card) {
            return response()->json([
                'success' => false,
                'message' => 'البطاقة غير موجودة'
            ], 404);
        }

        // إذا كانت البطاقة افتراضية، نجعل بطاقة أخرى افتراضية
        if ($card->is_default) {
            $otherCard = $user->paymentCards()
                ->where('id', '!=', $id)
                ->first();

            if ($otherCard) {
                $otherCard->update(['is_default' => true]);
            }
        }

        $card->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف البطاقة بنجاح'
        ]);
    }

    /**
     * اكتشاف نوع البطاقة (مساعدة)
     */
    private function detectCardType($cardNumber)
    {
        $firstTwo = substr($cardNumber, 0, 2);
        $firstFour = substr($cardNumber, 0, 4);

        if (preg_match('/^4/', $cardNumber)) {
            return 'visa';
        } elseif (preg_match('/^5[1-5]/', $cardNumber)) {
            return 'mastercard';
        } elseif (preg_match('/^3[47]/', $cardNumber)) {
            return 'amex';
        } elseif (preg_match('/^6(?:011|5)/', $cardNumber)) {
            return 'discover';
        }

        return 'unknown';
    }
}
