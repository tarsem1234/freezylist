<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\StoreXmlFeedRequest;
use App\Http\Requests\Backend\UpdateXmlFeedRequest;
use App\Models\XmlfeedUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class XmlFeedController extends Controller
{
    public function index(): View
    {
        $xmlUsers = XmlfeedUser::latest()->get();

        return view('backend.xml_feed.index', ['xmlUsers' => $xmlUsers]);
    }

    public function create(): View
    {
        return view('backend.xml_feed.create');
    }

    public function edit($id)
    {
        if ($id) {
            $xmlUser = XmlfeedUser::find(decrypt($id));
            if ($xmlUser) {
                return view('backend.xml_feed.create', compact('xmlUser'));
            }
        }

        return redirect()->back()->withFlashDanger('Something went wrong.');
    }

    public function store(StoreXmlFeedRequest $request, $id = null): RedirectResponse
    {
        $data = $request->all();
        unset($data['_token']);
        $data['password'] = Hash::make($data['password']);
        //        $user->username = $request->username;
        //        $user->password = bcrypt($request->password);

        if (XmlfeedUser::create($data)) {

            return redirect()->route('admin.xmlFeedIndex')->withFlashSuccess('Xml Feed User Created.');
        }

        return redirect()->back()->withFlashDanger('Something went wrong.');
    }

    public function update(UpdateXmlFeedRequest $request): RedirectResponse
    {
        if ($request->xml_user_id) {
            $xmlUserId = decrypt($request->xml_user_id);
            $data = [
                'username' => $request->username,
                'password' => $request->password,
            ];
            if (XmlfeedUser::where('id', $xmlUserId)->update($data)) {

                return redirect()->route('admin.xmlFeedIndex')->withFlashSuccess('Xml Feed User Updated.');
            }
        }

        return redirect()->back()->withFlashDanger('Something went wrong.');
    }

    public function activation($id): RedirectResponse
    {
        if ($id) {
            $xmlUser = XmlfeedUser::find(decrypt($id));
            if ($xmlUser && $xmlUser->status) {
                XmlfeedUser::where('id', $xmlUser->id)->Update(['status' => 0]);
            } elseif ($xmlUser && $xmlUser->status == 0) {
                XmlfeedUser::where('id', $xmlUser->id)->Update(['status' => 1]);
            }

            return redirect()->route('admin.xmlFeedIndex')->withFlashSuccess('Xml Feed User Updated.');
        }

        return redirect()->back()->withFlashDanger('Something went wrong.');
    }

    public function delete($id): RedirectResponse
    {
        if ($id) {
            if (XmlfeedUser::find($id)) {
                XmlfeedUser::where('id', $id)->delete();

                return redirect()->route('admin.xmlFeedIndex');
            }
        }

        return redirect()->back()->withFlashDanger('Something went wrong.');
    }
}
